document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');

    const btnCollapse = document.querySelector('.btn-collapse');
    const btnCollapsed = document.querySelector('.btn-collapsed');

    btnCollapse.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebar.classList.remove('lg:relative');
        sidebar.classList.remove('lg:translate-x-0');
    });

    btnCollapsed.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebar.classList.add('lg:relative');
        sidebar.classList.add('lg:translate-x-0');
    });

    const flashMessages = document.querySelectorAll('.flash-message');

    flashMessages.forEach((message) => {
        setTimeout(() => {
            message.remove();
        }, 5000);
    });

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    const imagePreviewInput = document.getElementById("image_preview_input");
    const preview = document.getElementById("image_preview");
    const imagePreviewSubmit = document.getElementById("image_preview_submit");

    if (!(imagePreviewInput && preview)) return;

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
});

//  pagina de criação de orçamentos
let selectedProducts = [];

document.getElementById('add-product').addEventListener('click', function () {
    console.log(1)

    const productSelect = document.getElementById('product_id');
    const productId = productSelect.value;
    const productName = productSelect.options[productSelect.selectedIndex].text;

    const quantityInput = document.getElementById('product_quantity');
    const quantity = parseInt(quantityInput.value);

    const priceInput = document.getElementById('product_price');
    const price = parseFloat(priceInput.value);

    if (!productId || quantity <= 0 || price <= 0 || typeof priceInput.value != 'number') {
        alert('Por favor, preencha todos os campos corretamente.');
        return;
    }

    console.log(price, priceInput.value, typeof price,);

    // Verificar se o produto já foi adicionado
    const existingProduct = selectedProducts.find(p => p.id === productId);
    if (existingProduct) {
        alert('Produto já adicionado. Você pode removê-lo e adicioná-lo novamente com novos valores.');
        return;
    }

    // Adicionar o produto ao array de produtos selecionados
    selectedProducts.push({
        id: productId,
        name: productName,
        quantity: quantity,
        price: price
    });

    // Atualizar a lista exibida
    const productList = document.getElementById('product-list');
    const listItem = document.createElement('li');
    listItem.textContent = `${productName} - Quantidade: ${quantity} - Preço: R$ ${price.toFixed(2)}`;

    // Botão para remover o produto da lista
    const removeButton = document.createElement('button');
    removeButton.textContent = 'Remover';
    removeButton.classList.add('ml-2', 'text-red-500', 'hover:underline');
    removeButton.addEventListener('click', function () {
        selectedProducts = selectedProducts.filter(p => p.id !== productId);
        document.getElementById('products-input').value = JSON.stringify(selectedProducts);
        productList.removeChild(listItem);
    });

    listItem.appendChild(removeButton);
    productList.appendChild(listItem);

    // Atualizar o campo hidden com os produtos selecionados
    document.getElementById('products-input').value = JSON.stringify(selectedProducts);

    // Limpar os campos de quantidade e preço
    quantityInput.value = '1';
    priceInput.value = '';
});
