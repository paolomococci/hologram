import hologramLogo from "./assets/hologram.svg";
import "./App.css";

const App = () => {
  return (
    <>
      <div>
        <a href="info.php" target="_blank" title="PHP info">
          <img src={hologramLogo} className="logo" alt="hologram logo" />
        </a>
      </div>
      <h1></h1>
      <div className="card">
        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit</h3>
      </div>
      <p className="read-the-docs">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit,
        molestiae repellat! Totam nam, velit recusandae ducimus voluptas alias
        sint quisquam debitis pariatur inventore dolor nesciunt odio, id rem sed
        impedit laudantium accusamus dolore vitae iure porro aut fugiat. Fugiat
        asperiores velit labore obcaecati nam, amet beatae ex eligendi sed eos.
      </p>
    </>
  );
};

export default App;
