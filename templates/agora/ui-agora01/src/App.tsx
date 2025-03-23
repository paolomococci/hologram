import { useState } from 'react'
import agoraLogo from './assets/star.svg'
import { Plus } from 'lucide-react'
import './App.css'

function App() {
	const [count, setCount] = useState(0)

	return (
		<>
			<header>
				<nav className="flex justify-center items-center">
					<a href="#" target="_blank">
						<img
							src={agoraLogo}
							className="scale-150 hover:scale-200 animate-[spin_3s_ease-in-out_infinite] logo"
							alt="agora"
						/>
					</a>
				</nav>
				{/* prose-base md:prose-lg lg:prose-xl */}
				<h1 className="text-sm font-light text-purple-600 uppercase md:text-xl lg:text-2xl">
					agora
				</h1>
			</header>

			<main className="m-2 card">
				<h3 className="mb-2 prose-lg md:prose-xl lg:prose-2xl prose-slate">
					increment button
				</h3>
				<button onClick={() => setCount((count) => count + 1)}>
					<Plus color="#777" size={32} />
				</button>
				<output className="block m-4 text-2xl md:text-4xl lg:text-6xl">
					{count}
				</output>
			</main>

			<footer className="card" id="info-note">
				<div className="fixed right-0 bottom-0 left-0 justify-center items-center">
					<p className="m-2 text-xs font-semibold text-purple-400 md:text-base lg:text-xl">
						For changes to this view the first file to edit is almost always:{' '}
						<code className="font-mono text-purple-300">src/App.tsx</code>.
					</p>
				</div>
			</footer>
		</>
	)
}

export default App
