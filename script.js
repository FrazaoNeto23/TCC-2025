let carrinho = [];
let contador = document.getElementById("contador");
let listaCarrinho = document.getElementById("lista-carrinho");
let total = document.getElementById("total");
let carrinhoDiv = document.getElementById("carrinho");
let fecharCarrinhoBtn = document.getElementById("fechar-carrinho");

function adicionarCarrinho(nome, preco) {
    carrinho.push({ nome, preco });
    atualizarCarrinho();
}

function atualizarCarrinho() {
    listaCarrinho.innerHTML = "";
    let totalCompra = 0;
    carrinho.forEach(item => {
        let li = document.createElement("li");
        li.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;
        listaCarrinho.appendChild(li);
        totalCompra += item.preco;
    });
    total.textContent = `Total: R$ ${totalCompra.toFixed(2)}`;
    contador.textContent = carrinho.length;
}

document.getElementById("carrinho-icon").addEventListener("click", () => {
    carrinhoDiv.classList.toggle("mostrar");
});

fecharCarrinhoBtn.addEventListener("click", () => {
    carrinhoDiv.classList.remove("mostrar");
});

document.getElementById("finalizar").addEventListener("click", () => {
    alert("Compra finalizada! Obrigado por pedir na Burger House 🍔");
    carrinho = [];
    atualizarCarrinho();
    carrinhoDiv.classList.remove("mostrar");
});
