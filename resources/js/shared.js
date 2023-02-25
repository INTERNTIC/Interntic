const getErrorText = (ErrorObject, property) => {
    return ErrorObject.hasOwnProperty(property) ? ErrorObject[property][0] : "";
}
export default {
    getErrorText
}