import { Component } from "@angular/core"
import { NgFor } from "@angular/common"
import { PostsService } from "./posts.service"
import { PostCardComponent } from "./post-card.component"

@Component({
  selector: "app-post-list",
  standalone: true,
  imports: [NgFor, PostCardComponent],
  template: `
    <section class="items-center app-card">
      <div>
        <h3 class="text-2xl text-slate-400">post list</h3>
      </div>
      <article>
        <div>
          <div class="p-4 m4" *ngFor="let post of postsService.posts">
            <h5 class="font-serif text-lg text-cyan-600">{{ post.title }}</h5>
            <app-post-card [post]="post"></app-post-card>
          </div>
        </div>
      </article>
    </section>
  `,
  styles: ``,
})
export class PostListComponent {
  constructor(readonly postsService: PostsService) {}

  ngOnInit(): void {}
}
