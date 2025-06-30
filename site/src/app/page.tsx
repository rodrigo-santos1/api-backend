import { BannerHome } from "./home/banner";
import { ClientesHome } from "./home/clientes";
import { FornecedorHome } from "./home/fornecedores";
import { ProdutosHome } from "./home/produtos";

export default function Home() {
  return (
    <div className="flex flex-col">
      <BannerHome />
      <ProdutosHome/>
      <ClientesHome/>
      <FornecedorHome/>
    </div>
  );
}