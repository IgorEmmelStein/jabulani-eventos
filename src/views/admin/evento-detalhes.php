<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Detalhes do Evento</title>
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

    <main class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-[#1e1e1e] rounded-xl border border-[#2d2d2d] p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#252525] text-[#10b981] border border-[#333333]">
                            <?= date('d/m/Y', strtotime($evento->getDataEvento())) ?>
                        </span>
                        <span class="text-xs text-gray-400"><?= htmlspecialchars($evento->getLocal()) ?></span>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white"><?= htmlspecialchars($evento->getTitulo()) ?></h1>
                    <p class="text-sm text-gray-400 mt-2 max-w-3xl"><?= htmlspecialchars($evento->getDescricao()) ?></p>
                </div>
                <div class="flex gap-2 self-start md:self-center">
                    <a href="editar?id=<?= $evento->getId() ?>" class="px-4 py-2 rounded-full text-xs font-semibold bg-[#252525] border border-[#333333] text-gray-300 hover:bg-[#2d2d2d] transition">Editar Dados</a>
                </div>
            </div>
        </div>

        <div class="bg-[#1e1e1e] rounded-xl border border-[#2d2d2d] overflow-hidden">
            <div class="px-6 py-5 border-b border-[#2d2d2d] flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white tracking-tight">Participantes Inscritos</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Lista de utilizadores registados para este evento.</p>
                </div>
                <div class="text-sm font-semibold bg-[#252525] border border-[#333333] px-4 py-1.5 rounded-full text-gray-300">
                    Total: <?= count($participantes) ?>
                </div>
            </div>

            <?php if (empty($participantes)): ?>
                <div class="text-center py-12 px-4">
                    <p class="text-gray-400 text-sm">Nenhum participante inscrito até ao momento.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1a1a1a] border-b border-[#2d2d2d] text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-4">Nome</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#2d2d2d] text-sm text-gray-300">
                            <?php foreach ($participantes as $participante): ?>
                                <tr class="hover:bg-[#252525]/30 transition">
                                    <td class="px-6 py-4 font-medium text-white">
                                        <?= htmlspecialchars($participante->getNomeUsuario()) ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <?= htmlspecialchars($participante->getEmail()) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="desinscrever?id=<?= $evento->getId() ?>&usuario_id=<?= $participante->getIdUsuario() ?>" 
                                           onclick="return confirm('Remover este participante do evento?')"
                                           class="inline-flex items-center justify-center bg-red-950/40 border border-red-800/40 px-3 py-1.5 rounded-full text-xs font-medium text-red-200 hover:bg-red-900/40 transition">
                                            Remover
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>