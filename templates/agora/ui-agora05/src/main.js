import './style.css'
import { createElement, Plus } from 'lucide'
import { setupCounter } from './counter.js'

const plusIcon = createElement(Plus)

document.querySelector('#app').innerHTML = `
  <div>
    <h3 class="text-indigo-400">Agora</h3>
    <div class="card">
      <button id="increment" class="text-indigo-400" type="button"></button>
      <output id="counter" for="increment" class="block mt-4 text-2xl text-indigo-400"></output>
    </div>
  </div>
`

document.querySelector('#increment').appendChild(plusIcon)

setupCounter(
  document.querySelector('#increment'),
  document.querySelector('#counter')
)
