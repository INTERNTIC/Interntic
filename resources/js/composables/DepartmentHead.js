export default ()=> {

    const updateDepartmentHead = async (id,department_head) => {
        await axios.patch("/editDepartmentHead/"+id,department_head)
    }

    return {
        updateDepartmentHead
    }
}