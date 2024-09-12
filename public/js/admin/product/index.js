
// const floatingWindow = document.getElementById('floatingWindow');
// const openWindowBtn = document.getElementById('openWindowBtn');
const floatingBody = document.querySelector('.floating-body')
console.log("test")
openWindowBtn.onclick = async function () {
    let url = 'http://demo.amall.ps/admin/catalog/product/create';
    fetch(url).then(response => {
        if (response.ok) {
            // console.log(response.text())
            return response.json();
        }
        throw new Error('Network response was not ok.');
    }).then(res => {
        floatingBody.innerHTML = res['html'];
        const link = document.createElement('link')
        const script = document.createElement('script')
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = res['css']

        script.src = res['js']
        document.head.appendChild(link);
        document.head.appendChild(script);

    })
}