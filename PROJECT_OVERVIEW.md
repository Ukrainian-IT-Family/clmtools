# CLMTools - Project Overview

## What this project does
CLMTools is a learning management platform for **students**, **lecturers**, and **admins**.
It supports course delivery workflows: creating courses/lectures/tasks, student submissions, grading, chat communication, and notifications.

## High-level architecture
- `api/`: Laravel 9 REST API (PHP 8.1), JWT-based auth, role middleware, MySQL, Redis/Beanstalkd support.
- `client/`: Vue 2 SPA (Vue Router + Vuex + BootstrapVue), served in dev by Vue CLI and in production by an Express static server.
- Realtime features use Laravel broadcasting + Pusher + Laravel Echo (chat and notifications).

## Implemented features

### Authentication and account
- User registration and login/logout.
- Email verification and resend verification email.
- Forgot password and reset password.
- Change password while authenticated.
- Profile update (`name`, `last name`, `birth date`, `city`, `university`, `graduation year`).
- Profile image upload with client-side cropper.

### Roles and access model
- Roles: `student`, `lecturer`, `admin` (plus `null` state for users without assigned role).
- Lecturer-only endpoints for managing educational content.
- Admin-only endpoints for user/role administration.
- Authenticated-only endpoints for chat, tasks, notifications, and handbook data.

### Lecturer capabilities
- Course management: create, edit, delete, list own courses, assign students.
- Lecture management: create, edit, delete, list own lectures, attach to course, assign students.
- Task management: create, edit, delete, list tasks, set student ratings.
- Lecturer chat panel: choose lecture + student, open/start chat, send messages/files.

### Student capabilities
- View own lectures and lecture details.
- Open lecture chat with lecturer.
- View assigned tasks (including tasks without lecture link).
- Submit task answers (repository/text answer flow).
- View answer details and received ratings.

### Chat and notifications
- Two-way lecturer-student chat with realtime message delivery.
- Chat supports file attachments (`.doc`, `.docx`, `.pdf`, up to 5MB in UI validation) and emoji picker.
- Realtime notifications when:
  - new chat messages arrive;
  - student submits task answer;
  - lecturer rates task answers.
- Notification center supports single delete, delete all, and deep-link navigation.

### Admin capabilities
- View user list.
- Search/filter users.
- Edit user role.
- Delete users.
- Fetch available roles from API.

### Supporting modules
- Handbook endpoints for cities and universities.
- Status endpoints for service health/status checks.
- Mail/event status test endpoints.
- English and Ukrainian localization in both backend language files and frontend i18n.

## API and UI structure summary
- API versioning under `/api/v1`.
- Frontend routes cover auth flow, profile, lectures, tasks, student tasks, chat, and lecturer chat.
- Vuex store is split into domain modules (`auth`, `courses`, `lections`, `tasks`, `student-tasks`, `chat`, `lecturer-chat`, `notifications`, `users`, `handbook`, `status-service`).

## Quality and automation
- Backend feature tests exist for auth, registration, password reset, users, roles, courses, lectures, tasks, chat, and profile image upload.
- GitHub Actions workflow runs backend tests with coverage and deploys from `master`.

## Current stack baseline (as found in repo)
- Backend: PHP 8.1, Laravel 9, MySQL 5.7, Redis, Beanstalkd.
- Frontend: Vue 2, Vuex 3, Vue Router 3, BootstrapVue, Node 12 tooling.
