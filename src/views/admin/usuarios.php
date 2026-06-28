<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-[#121212]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JabulaniEventos - Buscar Participantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full text-white bg-[#121212]">
    <nav class="bg-[#1e1e1e] border-b border-[#2d2d2d] p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="../dashboard" class="text-sm font-medium text-gray-400 hover:text-white transition">&larr; Voltar ao Dashboard</a>
            <span class="text-xs bg-[#252525] border border-[#333333] px-3 py-1 rounded-full text-gray-300">Admin</span>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex flex-col sm:flex-row justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold">Participantes do Sistema</h1>
            
            <form action="" method="GET" class="flex gap-2">
                <input type="text" name="busca" value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca'], ENT_QUOTES, 'UTF-8') : '' ?>" placeholder="Buscar nome ou email..." class="px-4 py-2 rounded-full bg-[#1e1e1e] border border-[#333333] text-white focus:outline-none focus:ring-2 focus:ring-[#10b981]">
                <button type="submit" class="bg-[#252525] hover:bg-[#2d2d2d] border border-[#333333] px-4 py-2 rounded-full font-medium transition">Buscar</button>
            </form>
        </div>

        <div class="bg-[#1e1e1e] border border-[#2d2d2d] rounded-xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#1a1a1a] border-b border-[#2d2d2d] text-xs text-gray-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nome</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-right">Data de Registo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2d2d2d] text-sm text-gray-300">
                    <?php if(empty($participantes)): ?>
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500">Nenhum participante encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($participantes as $p): ?>
                            <tr class="hover:bg-[#252525]/30">
                                <td class="px-6 py-4 font-medium text-white"><?= htmlspecialchars($p->getNomeUsuario(), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($p->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-6 py-4 text-right text-gray-500"><?= date('d/m/Y', strtotime($p->getRegistroCriado())) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>