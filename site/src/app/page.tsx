import { BannerHome } from "./home/banner";
import { ProdutosHome } from "./home/produtos";

export default function Home() {
  return (
    <div className="flex flex-col">
      <BannerHome />
      <ProdutosHome/>
    </div>
  );
}