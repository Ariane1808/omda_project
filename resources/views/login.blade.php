<!DOCTYPE html>
<html>
<head>
    <title>Login OMDA</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <h2>OFFICE MALAGASY DU DROIT D'AUTEUR</h2>
    <div class="form">
    <h2>Connexion Administrateur</h2>

    <form method="POST" action="/login">
        @csrf
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe :</label>
          <div class="input-group">
        <input type="password" id="password" name="password" class="form-control" required>
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            👁️
        </button>
    </div>

        <button type="submit">Se connecter</button>

        @if ($errors->any())
            <p style="color:red">{{ $errors->first() }}</p>
        @endif
    </form>
    </div>

    <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Change icon if you want
        this.textContent = type === "password" ? "👁️" : "🙈";
    });
</script>
</body>
</html>
