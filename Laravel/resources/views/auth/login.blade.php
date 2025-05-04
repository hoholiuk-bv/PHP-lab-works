<h2>Вхід</h2>
<form action="{{ route('login.submit') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Увійти</button>
</form>
