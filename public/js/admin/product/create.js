console.log("i'm here ")
let creatProductBtn = document.getElementById('creatProductBtn')
let createProductForm = document.forms['create-product'];


creatProductBtn.addEventListener('click', async function (event) {
    event.preventDefault();
    let formData = new FormData(createProductForm);
    console.log(formData);
    // token =
    let response = fetch(createProductForm.action, {
        method: 'POST',
        body: formData,
    }).then(response => {
        // console.log(response.text())
        return response.json();
    }).then(response => {
        if (response['success']) {
            let ProductCreated = document.createElement('div')
            ProductCreated.textContent = 'The Product Has been Created';
            ProductCreated.style.backgroundcolor = 'green';
            ProductCreated.style.color = 'white';
            ProductCreated.style.borderRadius = '15px';
            createProductForm.parentElement.appendChild(this.ProductCreated);
        } else {
            console.log('faild')
            let errors = response['errors'];
            let field = createProductForm;
            for (let i = 0; i < createProductForm.length; i++) {
                let name = field[i].getAttribute('name');
                console.log(name);
                console.log(field[i]);
                if (errors[name]) {
                    let error = document.createElement('div')
                    error.textContent = errors[name][0];
                    console.log(errors[name][0]);
                    console.log(error);

                    field[i].after(error);
                }
            }
            for (let i = 0; i < errors; i++) {
                let input = ProductCreated.querySelector(`.${errors[i]}`)
                console.log(input)
            }
        }
    })
})
