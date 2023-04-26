import { notify } from "@kyvg/vue3-notification";
const getErrorText = (ErrorObject, property) => {
    return ErrorObject.hasOwnProperty(property) ? ErrorObject[property][0] : "";
}
const token=sessionStorage.getItem('token');
const isUserCredentialsSaved=() =>window.sessionStorage.getItem('token')!==null || window.localStorage.getItem('token')!==null ;
const guards = ['student', 'internship_responsible', 'department_head', 'super_admin']

const successNotify=(generalSuccessMsg)=>{
    if(generalSuccessMsg!=''){
        $.NotificationApp.send("Well Done!", generalSuccessMsg, "top-right", "rgba(0,0,0,0.2)", "success")
        // notify({
        //         title: "Sccuess",
        //         text: generalSuccessMsg,
        //         type: "success",
        //     });
    }    
}
const errorNotify=(generalErrorMsg)=>{
    if(generalErrorMsg!=''){
        $.NotificationApp.send("Oh Ooops!", generalErrorMsg, "top-right", "rgba(0,0,0,0.2)", "error")
        // notify({
        //     title: "Error",
        //     text: generalErrorMsg,
        //     type: "error",
        // });
    }
}
const Notify=(generalSuccessMsg,generalErrorMsg)=>{
    successNotify(generalSuccessMsg)
    errorNotify(generalErrorMsg)
}
const refreshTable=(dataTable,newData)=>{
    dataTable.clear().draw();
    dataTable.rows.add(newData); // Add new data
    dataTable.columns.adjust().draw(); // Redraw the DataTable
}


export default {
    getErrorText,
    isUserCredentialsSaved,
    errorNotify,
    successNotify,
    Notify,
    refreshTable,
    guards,
    token
}