import agoraLogo from '../../assets/star.svg'

function AgoraLogo() {
	return (
		<>
			<img
				src={agoraLogo}
				className="scale-150 hover:scale-200 animate-[spin_3s_ease-in-out_infinite] logo"
				alt="agora"
			/>
		</>
	)
}

export default AgoraLogo
