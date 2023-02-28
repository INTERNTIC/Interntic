const getErrorText = (ErrorObject, property) => {
    return ErrorObject.hasOwnProperty(property) ? ErrorObject[property][0] : "";
}
const isUserCredentialsSaved=() =>window.sessionStorage.getItem('token')!==null || window.localStorage.getItem('token')!==null ;
const guards = ['student', 'internship_responssible', 'department_head', 'super_admin']
export default {
    getErrorText,
    isUserCredentialsSaved,
    guards
}