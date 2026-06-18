<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JabulaniEventos - Editar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full text-white bg-[#121212]">

    <nav class="bg-[#1e1e1e] border-b border-[#2d2d2d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <span class="text-2xl font-bold tracking-tight text-white">JabulaniEventos</span>
                    <a href="dashboard" class="text-sm font-medium text-gray-400 hover:text-white transition">Voltar ao Dashboard</a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs bg-[#252525] border border-[#333333] px-3 py-1 rounded-full capitalize text-gray-300">
                        <?= htmlspecialchars($_SESSION['usuario_tipo'] ?? 'participante', ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-white">Meu Perfil</h1>
            <p class="text-sm text-gray-400 mt-1">Atualize as suas informações pessoais.</p>
        </div>

        <div class="bg-[#1e1e1e] shadow sm:rounded-xl border border-[#2d2d2d] overflow-hidden">
            
            <?php if (isset($sucesso)): ?>
                <div class="m-6 mb-0 bg-green-900/50 border border-green-500 text-green-200 text-sm p-3 rounded-lg">
                    <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($erro)): ?>
                <div class="m-6 mb-0 bg-red-900/50 border border-red-500 text-red-200 text-sm p-3 rounded-lg">
                    <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form action="perfil" method="POST" class="p-6 sm:p-8 space-y-6">

                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-300">Nome completo *</label>
                    <div class="mt-1">

                        <input id="nome" name="nome" type="text" required 
                            value="<?= htmlspecialchars($_SESSION['usuario_nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email *</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required 
                            value="<?= htmlspecialchars($_SESSION['usuario_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    </div>
                </div>

                <div class="pt-4 border-t border-[#2d2d2d] flex items-center justify-end gap-3">
                    <a href="dashboard" class="px-5 py-2.5 rounded-full text-sm font-medium border border-[#333333] bg-[#252525] text-gray-300 hover:bg-[#2d2d2d] transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-full text-sm font-bold text-white bg-[#10b981] hover:bg-[#059669] transition shadow-sm">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>