<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Speciality;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class StudentGroupService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('GROUP_API_BASE_URL');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
        ]);
    }

    public function getAllStudyGroups($collegeId = null, $page = 1, $perPage = 10)
    {
        // Проверяем, был ли предоставлен collegeId
        if (is_null($collegeId)) {
            // Возвращаем пустой ответ, если collegeId не предоставлен
            return [
                'data' => [],
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => 0,
                'total_pages' => 0
            ];
        }
    
        $response = $this->client->request('GET', 'api/groups/v1/indexStudy-groups', [
            'query' => ['college_id' => $collegeId]
        ]);
    
        $studyGroups = json_decode($response->getBody()->getContents(), true);
    
        // Обогащаем данные о учебных группах информацией о департаментах и специальностях
        $studyGroups = $this->enrichStudyGroupsWithDepartments($studyGroups);
        $studyGroups = $this->enrichStudyGroupsWithSpecialities($studyGroups);
    
        // Переструктурируем учебные группы для вывода
        $structuredStudyGroups = array_map(function ($group) {
            return [
                'id' => $group['id'],
                'start_year' => $group['start_year'],
                'college_id' => $group['college_id'],
                'adviser_id' => $group['adviser_id'],
                'department_id' => $group['department_id'],
                'speciality_id' => $group['speciality_id'],
                'department_caption' => $group['department_caption'], // Добавляем это поле
                'speciality_title' => $group['speciality_title'], // Добавляем это поле
                'edu_base_title' => $group['edu_base_title'],
                'study_group_info' => $group['study_group_info'],
                'ref_study_group_to_qualifications' => $group['ref_study_group_to_qualifications'],
            ];
        }, $studyGroups);
    
        // Вычисляем смещение на основе текущей страницы и количества элементов на страницу
        $offset = ($page - 1) * $perPage;
    
        // Применяем смещение и лимит для пагинации
        $paginatedItems = array_slice($structuredStudyGroups, $offset, $perPage);
    
        // Подготавливаем и возвращаем данные пагинации
        return [
            'data' => $paginatedItems,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => count($structuredStudyGroups),
            'total_pages' => ceil(count($structuredStudyGroups) / $perPage)
        ];
    }

    protected function enrichStudyGroupsWithDepartments($studyGroups)
    {
        // Извлечение всех department_id из данных о учебных группах
        $departmentIds = collect($studyGroups)->pluck('department_id')->unique();

        // Загрузка данных о департаментах из базы данных
        $departments = Department::whereIn('id', $departmentIds)->get()->keyBy('id');

        // Добавление информации о caption к каждой учебной группе
        foreach ($studyGroups as &$studyGroup) {
            if (isset($studyGroup['department_id']) && isset($departments[$studyGroup['department_id']])) {
                $studyGroup['department_caption'] = $departments[$studyGroup['department_id']]->caption;
            } else {
                $studyGroup['department_caption'] = null; // Или можно установить другое значение по умолчанию
            }
        }

        return $studyGroups;
    }
    protected function enrichStudyGroupsWithSpecialities($studyGroups)
    {
        // Извлечение всех speciality_id из данных о учебных группах
        $specialityIds = collect($studyGroups)->pluck('speciality_id')->unique();

        // Загрузка данных о специальностях из базы данных
        $specialities = Speciality::whereIn('id', $specialityIds)->get()->keyBy('id');

        // Добавление информации о title к каждой учебной группе
        foreach ($studyGroups as &$studyGroup) {
            if (isset($studyGroup['speciality_id']) && isset($specialities[$studyGroup['speciality_id']])) {
                $studyGroup['speciality_title'] = $specialities[$studyGroup['speciality_id']]->title;
            } else {
                $studyGroup['speciality_title'] = null; // Или можно установить другое значение по умолчанию
            }
        }

        return $studyGroups;
    }


}
