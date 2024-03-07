<?php

namespace App\Services;

use App\Models\Curriculum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CurriculumService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => env('GROUP_API_BASE_URL'),
        ]);
    }
    public function createCurriculum($data)
    {
        // Проверка на существование Curriculum с такими же title, year, speciality_id, study_group_id и college_id
        $existingCurriculum = Curriculum::where('title', $data['title'])
            ->where('year', $data['year'])
            ->where('speciality_id', $data['speciality_id'])
            ->where('study_group_id', $data['study_group_id'])
            ->where('college_id', $data['college_id'])
            ->first();

        if ($existingCurriculum) {
            return ['error' => 'Curriculum with the provided title and data already exists.'];
        }

        $curriculum = Curriculum::create($data);
        return $curriculum;
    }

    public function getFilteredCurriculums($collegeId = null, $year = null)
    {
        $query = Curriculum::with('speciality'); // Жадная загрузка специальностей

        if (!is_null($collegeId)) {
            $query->where('college_id', $collegeId);
        }

        if (!is_null($year)) {
            $query->where('year', $year);
        }

        $curriculums = $query->get();

        foreach ($curriculums as $curriculum) {
            try {
                $response = $this->httpClient->request('GET', '/api/groups/v1/study-group-info/title', [
                    'query' => ['study_group_id' => $curriculum->study_group_id],
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                // Если заголовок title существует и не пуст, используем его, иначе присваиваем пустую строку
                $curriculum->study_group_title = $data['title'] ?? '';
            } catch (RequestException $e) {
                // Если произошла ошибка при запросе к API, присваиваем пустую строку
                $curriculum->study_group_title = '';
            }
        }

        return $curriculums;
    }
}
