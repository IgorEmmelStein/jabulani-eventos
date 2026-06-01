<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Gerenciar Evento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full text-white bg-[#121212]">

    <nav class="bg-[#1e1e1e] border-b border-[#2d2d2d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <span class="text-2xl font-bold tracking-tight text-white">EventHub</span>
                    <a href="../dashboard" class="text-sm font-medium text-gray-400 hover:text-white transition">Voltar ao Dashboard</a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs bg-[#252525] border border-[#333333] px-3 py-1 rounded-full capitalize text-gray-300"><?= $_SESSION['usuario_tipo'] ?></span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-white">
                <?= isset($evento) && $evento->getId() ? 'Editar Evento' : 'Criar Novo Evento' ?>
            </h1>
            <p class="text-sm text-gray-400 mt-1">Preencha os dados do evento de forma detalhada.</p>
        </div>

        <div class="bg-[#1e1e1e] shadow sm:rounded-xl border border-[#2d2d2d] overflow-hidden">
            <form action="<?= isset($evento) && $evento->getId() ? 'editar?id=' . $evento->getId() : 'criar' ?>" method="POST" class="p-6 sm:p-8 space-y-6">
                
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-300">Título do Evento *</label>
                    <div class="mt-1">
                        <input id="titulo" name="titulo" type="text" required placeholder="Ex: React Summit 2026" 
                            value="<?= isset($evento) ? htmlspecialchars($evento->getTitulo()) : '' ?>"
                            class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-300">Descrição *</label>
                    <div class="mt-1">
                        <textarea id="descricao" name="descricao" rows="4" required placeholder="Descreva o evento..." 
                            class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm"><?= isset($evento) ? htmlspecialchars($evento->getDescricao()) : '' ?></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="local" class="block text-sm font-medium text-gray-300">Local *</label>
                        <div class="mt-1">
                            <input id="local" name="local" type="text" required placeholder="Ex: São Paulo Convention Center" 
                                value="<?= isset($evento) ? htmlspecialchars($evento->getLocal()) : '' ?>"
                                class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm placeholder-gray-500 bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="dataEvento" class="block text-sm font-medium text-gray-300">Data do Evento *</label>
                        <div class="mt-1">
                            <input id="dataEvento" name="dataEvento" type="date" required 
                                value="<?= isset($evento) ? htmlspecialchars($evento->getDataEvento()) : '' ?>"
                                class="appearance-none block w-full px-4 py-2.5 border border-[#333333] rounded-md shadow-sm bg-[#252525] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#2d2d2d] flex items-center justify-end gap-3">
                    <a href="../dashboard" class="px-5 py-2.5 rounded-full text-sm font-medium border border-[#333333] bg-[#252525] text-gray-300 hover:bg-[#2d2d2d] transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-full text-sm font-bold text-white bg-[#10b981] hover:bg-[#059669] transition shadow-sm">
                        <?= isset($evento) && $evento->getId() ? 'Salvar Alterações' : 'Criar Evento' ?>
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>
</html>