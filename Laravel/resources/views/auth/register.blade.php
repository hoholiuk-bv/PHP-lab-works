<h2>Реєстрація</h2>
<form action="{{ route('register.submit') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Ім'я" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="password_confirmation" placeholder="Підтвердження паролю" required>
    <select name="role">
        <option value="client">Client</option>
        <option value="manager">Manager</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Зареєструватися</button>
</form>
