import { useState } from "react"
import { Plus } from "lucide-react"

export const Counter = () => {
  const [count, setCount] = useState(0)

  return (
    <>
      <h3 className="mb-2 prose-lg md:prose-xl lg:prose-2xl prose-slate">
        increment button
      </h3>
      <button onClick={() => setCount((count) => count + 1)}>
        <Plus color="#777" size={32} />
      </button>
      <output className="block m-4 text-2xl md:text-4xl lg:text-6xl">
        {count}
      </output>
    </>
  )
}
