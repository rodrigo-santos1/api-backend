export async function ProdutosHome() {

    interface Produto {
        id_produto: number;
        produto: string;
        descricao: string;
        imagem: string;
        preco: string;
    }

    const produtos = [
        {
            "id_produto": 4,
            "produto": "Meia adidas",
            "descricao": "boa",
            "id_marca": 2,
            "imagem": null,
            "quantidade": 2,
            "preco": "50.00",
            "marca": "Adidas"
        }
    ];

    const api = await fetch("http://localhost:8080/produtos",{
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((res) => {
        if(!res.ok){
            throw new Error("Erro ao buscar produtos");
        }
    }). catch((error) => {
        console.error("Erro ao buscar produtos:", error);
    }
    );
        
    return (
        <section className="w-full bg-gray-200 flex flex-col items-center justify-center py-10">
            <h2 className="text-5xl font-bold text-gray-800 mb-6">Produtos em Destaque</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-screen-xl px-4">
                {/* Exemplo de produto */}
                {produtos.map((produto, index) => (
                        <div key={index} className="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <img src="/produto-exemplo.jpg"
                                alt="Produto Exemplo"
                                className="w-full h-48 object-cover rounded-t-lg mb-4"
                            />
                            <h3 className="text-xl font-semibold text-gray-800">{produto.produto}</h3>
                            <p className="text-gray-600 mt-2">{produto.descricao}</p>
                            <span className="text-lg font-bold text-green-600 mt-2">{produto.preco}</span>
                        </div>
                    ))}
            </div>
        </section>
    );
}    