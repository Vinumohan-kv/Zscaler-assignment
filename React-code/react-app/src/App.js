import { Routes, Route } from "react-router-dom"
import { BrowserRouter } from "react-router-dom";
import Home from "./page/Home"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={ <Home />} />
        </Routes>
      </BrowserRouter>
    </div>
  )
}
export default App