document.addEventListener("DOMContentLoaded", () => {
    const imagePreviewInput = document.getElementById("image_preview_input");
    const preview = document.getElementById("image_preview");
    const imagePreviewSubmit = document.getElementById("image_preview_submit");

    if (imagePreviewInput && preview && imagePreviewSubmit) {
        imagePreviewInput.style.display = "none";
        imagePreviewSubmit.style.display = "none";

        preview.addEventListener("click", function () {
            imagePreviewInput.click();
        });

        imagePreviewInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("image_preview").src = e.target.result;
                    imagePreviewSubmit.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // AJAX para criar o orçamento
    const selectCustomerBtn = document.getElementById('select-customer');

    if (selectCustomerBtn) {
        selectCustomerBtn.addEventListener('click', async () => {
            const customerId = document.getElementById('budget_customer_id').value;
            try {
                const response = await fetch('/admin/budgets', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        customer_id: customerId
                    })
                });
                const data = await response.json();
                window.location.href = `/admin/budgets/${data.budget_id}/edit`;
            } catch (error) {
                console.error(error.message);
                alert(error.message);
            }
        });
    }

    // AJAX para adicionar produto no orçamento
    const addProductBtn = document.getElementById('add-product');

    if (addProductBtn) {
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
    }

    // AJAX para remover produto do orçamento
    const removeButtons = document.querySelectorAll('.remove-product');

    removeButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            const itemId = btn.getAttribute('data-id');
            const budgetId = document.getElementById('budget_id').value;
            try {
                const response = await fetch('/admin/budgets/remove_item', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: itemId, budget_id: budgetId })
                });
                await response.json();
                window.location.href = `/admin/budgets/${budgetId}/edit`;
            } catch (error) {
                console.error(error);
                alert(error.message);
            }
        });
    });

    // salva o orçamento e atualiza o status
    const saveBudgetBtn = document.getElementById('save-budget');

    if (saveBudgetBtn) {
        saveBudgetBtn.addEventListener('click', async () => {
            const budgetId = document.getElementById('budget_id').value;

            try {
                const response = await fetch('/admin/budgets/change_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        budget_id: budgetId,
                        status: 'pending'
                    })
                });

                await response.json();

                await fetch(`/admin/budgets/${budgetId}`);

                window.location.href = `/admin/budgets/${budgetId}`;
            } catch (error) {

                alert(error.message)
            }
        })
    }

    // cliente aprova orçamento
    const approveBudgetBtn = document.querySelectorAll('.approve-budget');
    const reproveBudgetBtn = document.querySelectorAll('.reprove-budget');

    if (approveBudgetBtn) {
        approveBudgetBtn.forEach(btn => {
            btn.addEventListener('click', async () => {
                const budgetId = btn.getAttribute('data-id');

                try {
                    const response = await fetch('/budgets/change_status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            budget_id: budgetId,
                            status: 'approved'
                        })
                    });

                    await response.json();

                    await fetch(`/budgets/${budgetId}`);

                    window.location.href = `/budgets`;
                } catch (error) {
                    alert(error.message)
                }
            })
        });
    }

    if (reproveBudgetBtn) {
        reproveBudgetBtn.forEach(btn => {
            btn.addEventListener('click', async () => {
                const budgetId = btn.getAttribute('data-id');

                try {
                    const response = await fetch('/budgets/change_status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            budget_id: budgetId,
                            status: 'reproved'
                        })
                    });

                    await response.json();

                    await fetch(`/budgets/${budgetId}`);

                    window.location.href = `/budgets`;
                } catch (error) {
                    alert(error.message)
                }
            })
        });
    }
});
