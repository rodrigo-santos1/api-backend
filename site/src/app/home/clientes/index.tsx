export async function ClientesHome() {

    interface Cliente {
        id_cliente: number;
        nome: string;
        email: string;
        imagem: string;
        whatsapp: string;
    }

    let clientes: { data: Cliente[] } = { data: [] };

    try {
        const request = await fetch('http://localhost:8080/clientes', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        clientes = await request.json();
    } catch (error) {
        console.error('Erro ao buscar cliente:', error);
    }

    return (
        <section className="w-full bg-gray-500 flex flex-col items-center justify-center py-10">
            <h2 className="text-5xl font-bold text-gray-800 mb-6">Clientes</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-screen-xl px-4">
                
                {Array.isArray(clientes.data) && clientes.data.map((cliente: Cliente, index: number) => (
                    <div
                        key={index}
                        className="bg-white p-6 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col items-center justify-center"
                        style={{ width: 260, height: 260 }}
                    >
                        <img
                            src={`http://localhost:8081/clientes/imagens/${cliente.imagem}`}
                            alt={cliente.nome}
                            className="w-24 h-24 object-cover rounded-full mb-4 border-4 border-gray-300"
                        />
                        <h3 className="text-lg font-semibold text-gray-800 text-center">{cliente.nome}</h3>
                        <p className="text-gray-600 text-center">{cliente.email}</p>
                        <p className="text-gray-600 text-center">{cliente.whatsapp}</p>
                    </div>
                ))}
            </div>
        </section>
    );
}    