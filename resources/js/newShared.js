// import { notify } from "@kyvg/vue3-notification";
export const getErrorText = (ErrorObject, property) => {
    return ErrorObject.hasOwnProperty(property) ? ErrorObject[property][0] : "";
}
// const token=sessionStorage.getItem('token');
// const isUserCredentialsSaved=() =>window.sessionStorage.getItem('token')!==null || window.localStorage.getItem('token')!==null ;
export const guards = ['student', 'internship_responsible', 'department_head', 'super_admin']

export const successNotify=(generalSuccessMsg)=>{
    if(generalSuccessMsg!=''){
        $.NotificationApp.send("Well Done!", generalSuccessMsg, "top-right", "rgba(0,0,0,0.2)", "success")
        // notify({
        //         title: "Sccuess",
        //         text: generalSuccessMsg,
        //         type: "success",
        //     });
    }    
}
export const errorNotify=(generalErrorMsg)=>{
    if(generalErrorMsg!=''){
        $.NotificationApp.send("Oh Ooops!", generalErrorMsg, "top-right", "rgba(0,0,0,0.2)", "error")
    }
}
export const Notify=(generalSuccessMsg,generalErrorMsg)=>{
    successNotify(generalSuccessMsg)
    errorNotify(generalErrorMsg)
}
export const refreshTable=(dataTable,newData)=>{
    dataTable.clear().draw();
    dataTable.rows.add(newData); // Add new data
    dataTable.columns.adjust().draw(); // Redraw the DataTable
}



