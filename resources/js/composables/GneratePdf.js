
export default () => {

    const downloadPdf = async (internship_request_id) => {
        await axios.get('/marks/generate-pdf/' + internship_request_id).then(response => {
            
            const url = response.data.data.pdf_url;
            window.open(url, '_blank');
        });
    }
    return {
        downloadPdf,
    }
}