<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\GetUserRolesAction;
use App\Actions\User\UserDeleteAction;
use App\Actions\User\GetStudentsAction;
use App\Actions\User\GetUsersAction;
use App\Actions\User\UserDeleteRequest;
use App\Actions\User\UserEditAction;
use App\Actions\User\UserEditRequest;
use App\Actions\User\UserEditVerificationRequest;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Presenters\UserRolesArrayPresenter;
use Illuminate\Http\JsonResponse;

class UserControllers extends ApiController
{
     /**
     * Getting all students for Lecturer
     */
    public function getStudents(
        GetStudentsAction $getStudentsAction,
        UserArrayPresenter $userArrayPresenter
    ): JsonResponse {
        $response = $getStudentsAction->execute();

        return $this->successResponse($userArrayPresenter->getCollections($response));
    }


    /**
     * Getting all users for admin
     */
    public function getUsers(
        GetUsersAction $getUsersAction,
        UserArrayPresenter $userArrayPresenter
    ): JsonResponse {
        $response = $getUsersAction->execute();

        return $this->successResponse($userArrayPresenter->getCollections($response));
    }

    /**
     * Edit user
     */
    public function editUser(
        $userId,
        UserEditVerificationRequest $userEditVerificationRequest,
        UserEditAction $userEditAction,
        UserArrayPresenter $userArrayPresenter
    ): JsonResponse {
        $request = new UserEditRequest(
            (int)$userId,
            $userEditVerificationRequest->get('role')
        );
        $response = $userEditAction->execute($request);

        return $this->successResponse($userArrayPresenter->present($response));
    }

    /**
     * Delete user
     */
    public function deleteUser(
        $userId,
        UserDeleteAction $userDeleteAction
    ): JsonResponse {
        $userDeleteAction->execute(new UserDeleteRequest(
            (int)$userId
        ));

        return $this->successResponse(["message" => __('user.deleted')]);
    }

    /**
     * Getting all user roles
     */
    public function getUserRoles(
        GetUserRolesAction $getStudentsAction
    ): JsonResponse {
        $response = $getStudentsAction->execute();

        return $this->successResponse($response);
    }
}
