export default {
  hasToken: state => !!state.token,
  isLoggedIn: state => state.isLoggedIn,
  hasAuthenticatedUser: state => !!state.user.id,
  getAuthenticatedUser: state => state.user,
  getToken: state => state.token,
  getFullName: state => `${state.user.name} ${state.user.lastName}`,
  getRegistrationUserId: state => state.registration_user,
  getStudentCourse: state => state.user.course,
  isLecturer: state => state.user.role === 'lecturer',
  isStudent: state => state.user.role === 'student',
  isNullUser: state => !state.user.role || state.user.role === 'null',
  isAdmin: state => state.user.role === 'admin',
};
