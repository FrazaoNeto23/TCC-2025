const produtos = [
    { id: 1, nome: "Pizza de Calabresa", preco: 45.00, img: "https://images.unsplash.com/photo-1601924582971-c6a1f7a8df20?auto=format&fit=crop&w=500&q=80" },
    { id: 2, nome: "Pizza de Mussarela", preco: 42.00, img: "https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?auto=format&fit=crop&w=500&q=80" },
    { id: 3, nome: "Pizza Portuguesa", preco: 48.00, img: "https://images.unsplash.com/photo-1542281286-9e0a16bb7366?auto=format&fit=crop&w=500&q=80" },
    { id: 4, nome: "Pizza de Frango c/ Catupiry", preco: 50.00, img: "https://images.unsplash.com/photo-1601924579440-9896c6f4f13e?auto=format&fit=crop&w=500&q=80" }
];

let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

function renderizarProdutos() {
    const container = document.getElementById("produtos");
    container.innerHTML = "";
    produtos.forEach(produto => {
        container.innerHTML += `
            <div class="produto">
                <img src="${produto.img}" alt="${produto.nome}">
                <h3>${produto.nome}</h3>
                <p>R$ ${produto.preco.toFixed(2)}</p>
                <button onclick="adicionarCarrinho(${produto.id})">Adicionar ao Carrinho</button>
            </div>
        `;
    });
}

function adicionarCarrinho(id) {
    const produto = produtos.find(p => p.id === id);
    carrinho.push(produto);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    atualizarQtdCarrinho();
}

function atualizarQtdCarrinho() {
    document.getElementById("qtd-carrinho").textContent = carrinho.length;
}

function mostrarCarrinho() {
    const aside = document.getElementById("carrinho");
    aside.classList.remove("oculto");
    const lista = document.getElementById("lista-carrinho");
    lista.innerHTML = "";
    let total = 0;
    carrinho.forEach(item => {
        lista.innerHTML += `<li>${item.nome} - R$ ${item.preco.toFixed(2)}</li>`;
        total += item.preco;
    });
    document.getElementById("total").textContent = total.toFixed(2);
}

function fecharCarrinho() {
    document.getElementById("carrinho").classList.add("oculto");
}

function finalizarCompra() {
    alert("Compra finalizada! Obrigado pela preferência 🍕");
    carrinho = [];
    localStorage.removeItem("carrinho");
    atualizarQtdCarrinho();
    fecharCarrinho();
}

renderizarProdutos();
atualizarQtdCarrinho();
