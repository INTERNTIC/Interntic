export default ()=> {


    const updateInternshipResponsible = async (id,internship_responsible) => {
        await axios.patch("/internshipResponsibles/"+id,internship_responsible)
    }

    return {
        updateInternshipResponsible
    }
}