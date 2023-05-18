export default ()=> { 

    const updateDepartment = async (id,department) => {
        await axios.patch('/departments/'+id, department)
    }
   
    return {       
        updateDepartment,
    }
}