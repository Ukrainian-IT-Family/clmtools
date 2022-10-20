<?php

namespace App\Http\Controllers\Api;

use App\Actions\Lecture\LectureDeleteAction;
use App\Actions\Lecture\LectureDeleteRequest;
use App\Actions\Lecture\LectureEditAction;
use App\Actions\Lecture\LectureEditRequest;
use App\Actions\Lecture\LectureEditVerificationRequest;
use App\Actions\Lecture\LectureAction;
use App\Actions\Lecture\LectureCollectionAction;
use App\Actions\Lecture\LectureCollectionRequest;
use App\Actions\Lecture\LectureCreateAction;
use App\Actions\Lecture\LectureCreateRequest;
use App\Actions\Lecture\GetLecturesByAuthorAction;
use App\Actions\Lecture\LectureRequest;
use App\Actions\Lecture\LectureVerificationRequest;
use App\Http\Presenters\LectureArrayPresenter;
use Illuminate\Http\JsonResponse;

class LectureControllers extends ApiController
{
    /**
     * Getting lectures list for user
     */
    public function userLectures(
        $userId,
        LectureCollectionAction $lectureCollectionAction,
        LectureArrayPresenter $lectureArrayPresenter
    ): JsonResponse {
        $response = $lectureCollectionAction->execute(new LectureCollectionRequest(
            (int)$userId
        ));

        return $this->successResponse($lectureArrayPresenter->getCollections($response));
    }

    /**
     * Getting lecture data
     */
    public function lecture(
        $lectureId,
        LectureAction $lectureAction,
        LectureArrayPresenter $lectureArrayPresenter
    ): JsonResponse {
        $response = $lectureAction->execute(new LectureRequest(
            (int)$lectureId
        ));

        return $this->successResponse($lectureArrayPresenter->present($response));
    }

    /**
     * Getting all data for lecturer
     */
    public function getLectures(
        GetLecturesByAuthorAction $getLecturesByAuthorAction,
        LectureArrayPresenter $lectureArrayPresenter
    ): JsonResponse {
        $response = $getLecturesByAuthorAction->execute();

        return $this->successResponse($lectureArrayPresenter->getCollections($response));
    }

    /**
     * Create a new lecture
     */
    public function createLecture(
        LectureVerificationRequest $lectureVerificationRequest,
        LectureCreateAction $lectureCreateAction,
        LectureArrayPresenter $lectureArrayPresenter
    ): JsonResponse {
        $request = new LectureCreateRequest(
            $lectureVerificationRequest->get('title'),
            $lectureVerificationRequest->get('description'),
            $lectureVerificationRequest->get('link'),
            $lectureVerificationRequest->get('course_id'),
            $lectureVerificationRequest->get('user_id')
        );
        $response = $lectureCreateAction->execute($request);

        return $this->successResponse($lectureArrayPresenter->present($response));
    }

    /**
     * Edit lecture
     */
    public function editLecture(
        $lectureId,
        LectureEditVerificationRequest $lectureEditVerificationRequest,
        LectureEditAction $lectureEditAction,
        LectureArrayPresenter $lectureArrayPresenter
    ): JsonResponse {
        $request = new LectureEditRequest(
            (int)$lectureId,
            $lectureEditVerificationRequest->get('title'),
            $lectureEditVerificationRequest->get('description'),
            $lectureEditVerificationRequest->get('link'),
            $lectureEditVerificationRequest->get('course_id'),
            $lectureEditVerificationRequest->get('user_id')
        );
        $response = $lectureEditAction->execute($request);

        return $this->successResponse($lectureArrayPresenter->present($response));
    }

    /**
     * Delete lecture
     */
    public function deleteLecture(
        $lectureId,
        LectureDeleteAction $lectureDeleteAction
    ): JsonResponse {
        $lectureDeleteAction->execute(new LectureDeleteRequest(
            (int)$lectureId
        ));

        return $this->successResponse(["message" => __('lection.deleted')]);
    }
}
