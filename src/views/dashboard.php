<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full text-white bg-[#121212]">

    <nav class="bg-[#1e1e1e] border-b border-[#2d2d2d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <span class="text-2xl font-bold tracking-tight text-white">EventHub</span>
                    <div class="hidden md:block">
                        <div class="flex items-baseline space-x-4">
                            <a href="dashboard" class="bg-[#252525] text-white px-3 py-2 rounded-md text-sm font-medium border border-[#333333]">Eventos</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-medium text-white"><?= $_SESSION['usuario_nome'] ?></div>
                        <div class="text-xs text-gray-400 capitalize"><?= $_SESSION['usuario_tipo'] ?></div>
                    </div>
                    <a href="logout" class="bg-red-900/40 hover:bg-red-900/60 text-red-200 px-4 py-2 rounded-full text-sm font-medium border border-red-700/50 transition duration-150">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-4 sm:px-0">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <form action="dashboard" method="GET" class="flex-1 max-w-md flex gap-2">
                    <input type="text" name="busca" value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>" placeholder="Buscar eventos..." 
                        class="appearance-none block w-full px-4 py-2 border border-[#333333] rounded-full placeholder-gray-500 bg-[#1e1e1e] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] sm:text-sm">
                    <button type="submit" class="bg-[#252525] border border-[#333333] hover:bg-[#2d2d2d] px-4 py-2 rounded-full text-sm font-medium transition">Buscar</button>
                </form>

                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <div class="flex gap-2">
                        <a href="evento/criar" class="inline-flex items-center justify-center py-2 px-5 rounded-full text-sm font-medium text-white bg-[#10b981] hover:bg-[#059669] transition font-bold shadow-sm">
                            Criar Novo Evento
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (empty($eventos)): ?>
                <div class="text-center py-12 bg-[#1e1e1e] rounded-lg border border-[#2d2d2d]">
                    <p class="text-gray-400 text-sm">Nenhum evento encontrado para a listagem.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($eventos as $evento): ?>
                        <div class="bg-[#1e1e1e] overflow-hidden rounded-xl border border-[#2d2d2d] flex flex-col justify-between transition hover:border-[#3d3d3d]">
                            <div class="p-6">
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#252525] text-gray-300 border border-[#333333]">
                                        <?= date('d/m/Y', strtotime($evento->getDataEvento())) ?>
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        <?= htmlspecialchars($evento->getLocal()) ?>
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-2 tracking-tight">
                                    <?= htmlspecialchars($evento->getTitulo()) ?>
                                </h3>
                                <p class="text-sm text-gray-400 line-clamp-3">
                                    <?= htmlspecialchars($evento->getDescricao()) ?>
                                </p>
                            </div>
                            
                            <div class="px-6 py-4 bg-[#1a1a1a] border-t border-[#2d2d2d] flex items-center justify-between gap-2">
                                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                                    <a href="evento/detalhes?id=<?= $evento->getId() ?>" class="text-xs font-semibold text-[#10b981] hover:underline">Participantes</a>
                                    <div class="flex gap-2">
                                        <a href="evento/editar?id=<?= $evento->getId() ?>" class="text-xs bg-[#252525] border border-[#333333] px-2.5 py-1.5 rounded text-gray-300 hover:bg-[#2d2d2d]">Editar</a>
                                        <a href="evento/excluir?id=<?= $evento->getId() ?>" onclick="return confirm('Confirmar exclusao?')" class="text-xs bg-red-950/40 border border-red-800/40 px-2.5 py-1.5 rounded text-red-200 hover:bg-red-900/40">Excluir</a>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs text-gray-500">Ações disponíveis</span>
                                    <?php if (in_array($evento->getId(), $meusEventosIds)): ?>
                                        <a href="evento/desinscrever?id=<?= $evento->getId() ?>" class="text-xs bg-red-900/50 hover:bg-red-900/70 text-red-200 px-3 py-1.5 rounded-full font-medium transition border border-red-700/50">Cancelar Inscrição</a>
                                    <?php else: ?>
                                        <a href="evento/inscrever?id=<?= $evento->getId() ?>" class="text-xs bg-[#10b981] hover:bg-[#059669] text-white px-4 py-1.5 rounded-full font-bold transition">Inscrever-se</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>