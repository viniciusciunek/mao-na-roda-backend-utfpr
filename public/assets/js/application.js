document.addEventListener("DOMContentLoaded", () => {
    // const btn = document.getElementById('mobile-menu-button');
    // const sidebar = document.getElementById('sidebar');

    // const btnCollapse = document.querySelector('.btn-collapse');
    // const btnCollapsed = document.querySelector('.btn-collapsed');

    // btnCollapse.addEventListener('click', () => {
    //     sidebar.classList.toggle('translate-x-0');
    //     sidebar.classList.remove('lg:relative');
    //     sidebar.classList.remove('lg:translate-x-0');
    // });

    // btnCollapsed.addEventListener('click', () => {
    //     sidebar.classList.toggle('translate-x-0');
    //     sidebar.classList.add('lg:relative');
    //     sidebar.classList.add('lg:translate-x-0');
    // });

    // const flashMessages = document.querySelectorAll('.flash-message');

    // flashMessages.forEach((message) => {
    //     setTimeout(() => {
    //         message.remove();
    //     }, 5000);
    // });

    // btn.addEventListener('click', () => {
    //     sidebar.classList.toggle('-translate-x-full');
    // });

    // const imagePreviewInput = document.getElementById("image_preview_input");
    // const preview = document.getElementById("image_preview");
    // const imagePreviewSubmit = document.getElementById("image_preview_submit");

    // if (!(imagePreviewInput && preview)) return;

    // imagePreviewInput.style.display = "none";
    // imagePreviewSubmit.style.display = "none";

    // preview.addEventListener("click", function () {
    //     imagePreviewInput.click();
    // });

    // imagePreviewInput.addEventListener("change", function (event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function (e) {
    //             document.getElementById("image_preview").src = e.target.result;
    //             imagePreviewSubmit.style.display = "block";
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });



    // ajax para criar o orçamento antes
    // const selectCustomerBtn = document.getElementById('select-customer');

    // selectCustomerBtn.addEventListener('click', async () => {
    //     const customerId = document.getElementById('budget_customer_id').value;

    //     try {
    //         const response = await fetch('/admin/budgets', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify({
    //                 customer_id: customerId
    //             })
    //         });

    //         const data = await response.json();

    //         window.location.href = `/admin/budgets/${data.budget_id}/edit`;
    //     } catch (error) {
    //         console.error(error.message);
    //         console.log(error.message)
    //         alert(error.message);
    //     }
    // });


    // ajax para adicionar produto no orçamento
    const addProductBtn = document.getElementById('add-product');

    addProductBtn.addEventListener('click', async () => {
        const productId = document.getElementById('product_id').value;
        const budgetId = document.getElementById('budget_id').value;
        const quantity = document.getElementById('product_quantity').value;
        const price = document.getElementById('product_price').value;

        try {
            const response = await fetch('/admin/budgets/add_item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    budget_id: budgetId,
                    product_id: productId,
                    quantity: quantity,
                    price: price
                })
            });

            const data = await response.json();

            window.location.href = `/admin/budgets/${budgetId}/edit`;
        } catch (error) {
            console.error(error.message);
            alert(error.message);
        }
    });

    // ajax para remover produto do orçamento
    const removeButtons = document.querySelectorAll('.remove-product');

    removeButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            const itemId = btn.getAttribute('data-id');
            const budgetId = document.getElementById('budget_id').value;

            console.log(itemId, budgetId);

            try {
                const response = await fetch('/admin/budgets/remove_item', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: itemId })
                });

                await response.json();

                window.location.href = `/admin/budgets/${budgetId}/edit`;
            } catch (error) {
                console.error(error);
                alert(error.message);
            }
        });
    });
});
