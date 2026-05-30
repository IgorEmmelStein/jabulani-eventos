<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Criar Conta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 text-white">

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-white mb-2">EventHub</h1>
        <p class="text-sm text-gray-400">Crie sua conta grátis</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-[#1e1e1e] py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-[#2d2d2d]">
            
            <?php if (isset($erro)): ?>
                <div class="mb-4 bg-red-900/50 border border-red-500 text-red-200 text-sm p-3 rounded-lg">
                    <?= $erro ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="cadastro" method="POST">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-300">Nome completo</label>
                    <div class="mt-1">
                        <input id="nome" name="nome" type="text" required placeholder="Seu nome" 
                            class="appearance-none block w-full px-3 py-2 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required placeholder="seu@email.com" 
                            class="appearance-none block w-full px-3 py-2 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-300">Senha</label>
                    <div class="mt-1">
                        <input id="senha" name="senha" type="password" required placeholder="••••••••" 
                            class="appearance-none block w-full px-3 py-2 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-[#10b981] hover:bg-[#059669] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10b981] transition duration-150 ease-in-out font-bold">
                        Criar conta
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Já possui uma conta? 
                    <a href="login" class="font-medium text-[#10b981] hover:text-[#059669] transition duration-150">
                        Faça login
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>