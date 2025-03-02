import { Component, Input } from "@angular/core"

@Component({
  selector: "app-post-card",
  standalone: true,
  imports: [],
  template: `
    <div>
      <p class="m-2 font-serif text-justify line-clamp-2 text-stone-400">{{ post.content }}</p>
      <p class="font-mono text-sm text-cyan-400">{{ post.author }}</p>
    </div>
  `,
  styles: ``,
})
export class PostCardComponent {
  @Input() post: any
}
