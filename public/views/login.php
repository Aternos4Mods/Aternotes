<main>
    <div class="container">
        <div class="login__container">
            <h1 class="login__header">Log in</h1>
            <img class="login__image" src="images/logo_green.png" alt="logo">
            <form id="loginForm" class="login__form" action="" method="post">
                <div class="login__input__container">
                    <label for="username" class="login__label">Username</label>
                    <input type="text" id="username" name="username" class="login__input" required>
                </div>
                <div class="login__input__container">
                    <label for="password" class="login__label">Password</label>
                    <input type="password" id="password" name="password" class="login__input" required>
                </div>
                <button type="submit" class="login__button">Log in</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from reloading the page

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const formData = {
                function: 'userHandler',
                username: username,
                password: password,
            }
            fetch('api/login', {
                method: 'POST', 
                headers:{
                    'Content-Type': 'application/json', 
                },
                body: JSON.stringify(formData)
            })
                .then(data => console.log(data))
                .catch(error => {console.error(error)})
            
            
        
        });

    </script>

</main>