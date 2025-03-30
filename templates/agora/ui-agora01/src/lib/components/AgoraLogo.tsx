import agoraLogo from "../../assets/star.min.svg"

function AgoraLogo() {
  return (
    <>
      <img
        src={agoraLogo}
        className="scale-200 hover:scale-200 animate-[spin_3s_ease-in-out_infinite] logo"
        alt="agora"
      />
    </>
  )
}

export default AgoraLogo
