import { Component } from '@angular/core'
import { NgFor } from "@angular/common"
import { PostsService } from './posts.service'

@Component({
  selector: 'app-post-list',
  standalone: true,
  imports: [NgFor],
  template: `
    <section class="app-card">
      <div>
        <h3>post list</h3>
      </div>
      <article>
        <ul>
          <li *ngFor="let post of postsService.posts">
            {{ post.title }}
            <ul>
              <li>{{ post.content }}</li>
              <li>{{ post.author }}</li>
            </ul>
          </li>
        </ul>
      </article>
    </section>
  `,
  styles: ``
})
export class PostListComponent {

  constructor(readonly postsService: PostsService) {}

  ngOnInit(): void {}
}
