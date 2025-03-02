import { Injectable } from '@angular/core'

interface Post {
  title: string
  content: string
  author: string
}

@Injectable({
  providedIn: 'root'
})
export class PostsService {

  // array of fake posts for testing purposes only
  posts: Post[] = [
    {
      title: "Mouse, who was peeping anxiously.",
      content: "ME.' 'You!' said the Caterpillar took the least idea what…",
      author: "olin.kertzmann1@example.local"
    },
    {
      title: "VERY deeply with a knife, it.",
      content: "Cat,' said Alice: 'I don't much care where--' said Alice…",
      author: "norwood.goodwin0@thesis.local"
    },
    {
      title: "Queen put on her lap as if a dish.",
      content: "I fancied that kind of thing never happened, and now…",
      author: "giovanni.runolfsson5@example.local"
    },
    {
      title: "She ate a little pattering of.",
      content: "How puzzling all these strange Adventures of hers would, in…",
      author: "dino.greenfelder3@example.local"
    },
    {
      title: "Forty-two. ALL PERSONS MORE THAN.",
      content: "She had just upset the week before. 'Oh, I BEG…",
      author: "grady.farrell.iv0@thesis.local"
    },
  ]

  constructor() { }
}
