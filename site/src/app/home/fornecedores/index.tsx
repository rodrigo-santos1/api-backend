export async function FornecedorHome() {

    interface fornecedor {
        fornecedor: string;
        nome: string;
        cnpj: string;
        email: string;
        telefone: string;
        
    }

    let fornecedores: { data: fornecedor[] } = { data: [] };

    try {
        const request = await fetch('http://localhost:8080/fornecedores', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        fornecedores = await request.json();
    } catch (error) {
        console.error('Erro ao buscar fornecedores:', error);
    }

    return (
        <section className="w-full bg-gray-400 flex flex-col items-center justify-center py-10">
            <h2 className="text-5xl font-bold text-gray-800 mb-6">Fornecedores</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-screen-xl px-4">
                
                {Array.isArray(fornecedores.data) && fornecedores.data.map((fornecedor: fornecedor, index: number) => (
                    <div
                        key={index}
                        className="relative bg-white p-4 shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col items-center"
                        style={{
                            clipPath: 'polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%)',
                            borderRadius: '0', 
                        }}
                    >
                        <h3 className="text-xl font-semibold text-gray-800 text-center break-all">{fornecedor.nome}</h3>
                        <p className="text-gray-600 text-center break-all">CNPJ: {fornecedor.cnpj}</p>
                        <p className="text-gray-600 text-center break-all">Email: {fornecedor.email}</p>
                        <p className="text-gray-600 text-center break-all">Telefone: {fornecedor.telefone}</p>
                    </div>
                ))}
            </div>
        </section>
    );
}    