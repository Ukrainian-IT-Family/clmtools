<?php

namespace App\Http\Controllers\Api;

use App\Actions\Course\CourseCreateAction;
use App\Actions\Course\CourseCreateRequest;
use App\Actions\Course\CourseDeleteAction;
use App\Actions\Course\CourseDeleteRequest;
use App\Actions\Course\CourseEditAction;
use App\Actions\Course\CourseEditRequest;
use App\Actions\Course\CourseEditVerificationRequest;
use App\Actions\Course\GetCoursesByAuthorAction;
use App\Actions\Course\CourseVerificationRequest;
use App\Http\Presenters\CourseArrayPresenter;
use Illuminate\Http\JsonResponse;

class CourseControllers extends ApiController
{
     /**
     * Getting all courses of Lecturer
     */
    public function getCourses(
        GetCoursesByAuthorAction $getCoursesByAuthorAction,
        CourseArrayPresenter $courseArrayPresenter
    ): JsonResponse {
        $response = $getCoursesByAuthorAction->execute();

        return $this->successResponse($courseArrayPresenter->getCollections($response));
    }

    /**
     * Create a new Course
     */
    public function createCourse(
        CourseVerificationRequest $courseVerificationRequest,
        CourseCreateAction $courseCreateAction,
        CourseArrayPresenter $courseArrayPresenter
    ): JsonResponse {
        $request = new CourseCreateRequest(
            $courseVerificationRequest->get('title'),
            $courseVerificationRequest->get('user_id')
        );
        $response = $courseCreateAction->execute($request);

        return $this->successResponse($courseArrayPresenter->present($response));
    }

    /**
     * Edit Course
     */
    public function editCourse(
        $courseId,
        CourseEditVerificationRequest $courseEditVerificationRequest,
        CourseEditAction $courseEditAction,
        CourseArrayPresenter $courseArrayPresenter
    ): JsonResponse {
        $request = new CourseEditRequest(
            (int)$courseId,
            $courseEditVerificationRequest->get('title'),
            $courseEditVerificationRequest->get('user_id')
        );
        $response = $courseEditAction->execute($request);

        return $this->successResponse($courseArrayPresenter->present($response));
    }

    /**
     * Delete Course
     */
    public function deleteCourse(
        $courseId,
        CourseDeleteAction $courseDeleteAction
    ): JsonResponse {
        $courseDeleteAction->execute(new CourseDeleteRequest(
            (int)$courseId
        ));

        return $this->successResponse(["message" => __('course.deleted')]);
    }
}
