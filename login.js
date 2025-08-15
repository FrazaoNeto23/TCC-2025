// --- Helpers de armazenamento ---
const USERS_KEY = "bh_users";
const SESSION_KEY = "bh_session_email";

const readUsers = () => JSON.parse(localStorage.getItem(USERS_KEY) || "[]");
const writeUsers = (arr) => localStorage.setItem(USERS_KEY, JSON.stringify(arr));
const setSession = (email) => localStorage.setItem(SESSION_KEY, email);
const getSession = () => localStorage.getItem(SESSION_KEY);
const clearSession = () => localStorage.removeItem(SESSION_KEY);

// (Demonstração) "hashing" simples — em produção use um backend com hash real!
const fakeHash = (str) => btoa(unescape(encodeURIComponent(str)));

// --- Tabs (Entrar/Cadastrar) ---
document.querySelectorAll(".tab").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
        document.querySelectorAll(".panel").forEach(p => p.classList.remove("active"));
        btn.classList.add("active");
        const target = document.querySelector(btn.dataset.target);
        if (target) target.classList.add("active");
    });
});

// --- Mostrar/ocultar senha ---
document.querySelectorAll(".showpass").forEach(btn => {
    btn.addEventListener("click", () => {
        const input = document.getElementById(btn.dataset.target);
        if (!input) return;
        input.type = input.type === "password" ? "text" : "password";
    });
});

// --- Login ---
const loginForm = document.getElementById("login");
const loginMsg = document.getElementById("login-msg");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    loginMsg.textContent = ""; loginMsg.className = "msg";

    const email = document.getElementById("login-email").value.trim().toLowerCase();
    const senha = document.getElementById("login-senha").value;

    const users = readUsers();
    const user = users.find(u => u.email === email && u.hash === fakeHash(senha));

    if (!user) {
        loginMsg.textContent = "E-mail ou senha inválidos.";
        loginMsg.classList.add("err");
        return;
    }

    setSession(email);
    loginMsg.textContent = "Login realizado! Redirecionando…";
    loginMsg.classList.add("ok");

    // “Lembrar-me”: mantém a sessão (localStorage já persiste). Sem lembrar, poderíamos limpar ao sair.
    // Se quiser implementar “não lembrar”, use sessionStorage.

    // Redireciona para a home após 700ms
    setTimeout(() => { window.location.href = "index.html"; }, 700);
});

// --- Cadastro ---
const signupForm = document.getElementById("signup");
const signupMsg = document.getElementById("signup-msg");

signupForm.addEventListener("submit", (e) => {
    e.preventDefault();
    signupMsg.textContent = ""; signupMsg.className = "msg";

    const nome = document.getElementById("cad-nome").value.trim();
    const email = document.getElementById("cad-email").value.trim().toLowerCase();
    const senha = document.getElementById("cad-senha").value;
    const confirmar = document.getElementById("cad-confirmar").value;

    if (senha.length < 6) {
        signupMsg.textContent = "A senha deve ter pelo menos 6 caracteres.";
        signupMsg.classList.add("err");
        return;
    }
    if (senha !== confirmar) {
        signupMsg.textContent = "As senhas não coincidem.";
        signupMsg.classList.add("err");
        return;
    }

    const users = readUsers();
    if (users.some(u => u.email === email)) {
        signupMsg.textContent = "Já existe uma conta com este e-mail.";
        signupMsg.classList.add("err");
        return;
    }

    users.push({ nome, email, hash: fakeHash(senha), criadoEm: new Date().toISOString() });
    writeUsers(users);

    signupMsg.textContent = "Conta criada! Você já pode entrar.";
    signupMsg.classList.add("ok");

    // Troca para a aba de login
    document.querySelector('.tab[data-target="#login"]').click();
});

// --- Recuperar senha (somente demo) ---
document.getElementById("recuperar-link").addEventListener("click", (e) => {
    e.preventDefault();
    const email = prompt("Digite seu e-mail para enviar instruções (demonstração):");
    if (!email) return;
    alert("Se este e-mail estiver cadastrado, enviaremos instruções (demo).");
});
