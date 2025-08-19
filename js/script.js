let carrinho = [];
let contador = document.getElementById("contador");
let listaCarrinho = document.getElementById("lista-carrinho");
let total = document.getElementById("total");
let carrinhoDiv = document.getElementById("carrinho");
let fecharCarrinhoBtn = document.getElementById("fechar-carrinho");

function adicionarCarrinho(nome, preco, imagem) {
    carrinho.unshift({ nome, preco, imagem });
    atualizarCarrinho();
}

function removerItem(index) {
    carrinho.splice(index, 1);
    atualizarCarrinho();
}

function atualizarCarrinho() {
    listaCarrinho.innerHTML = "";
    let totalCompra = 0;

    carrinho.forEach((item, index) => {
        let li = document.createElement("li");

        let img = document.createElement("img");
        img.src = item.imagem;
        img.alt = item.nome;

        let span = document.createElement("span");
        span.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;

        let btnRemover = document.createElement("button");
        btnRemover.textContent = "✖";
        btnRemover.classList.add("remover-item");
        btnRemover.addEventListener("click", () => removerItem(index));

        li.appendChild(img);
        li.appendChild(span);
        li.appendChild(btnRemover);

        listaCarrinho.appendChild(li);
        totalCompra += item.preco;
    });

    total.textContent = `Total: R$ ${totalCompra.toFixed(2)}`;
    contador.textContent = carrinho.length;
    listaCarrinho.scrollTop = 0;

    if(listaCarrinho.firstChild){
        listaCarrinho.firstChild.classList.add("destacado");
        setTimeout(()=>{ listaCarrinho.firstChild.classList.remove("destacado"); },1000);
    }
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
