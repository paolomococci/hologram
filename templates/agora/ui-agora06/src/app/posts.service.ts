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
      content: "ME.' 'You!' said the Caterpillar took the least idea what to do so. 'Shall we try another figure of the tale was something like it,' said Alice, 'and why it is to France-- Then turn not pale, beloved snail, but come and join the dance. 'What matters it how far we go? his scaly friend replied. There is another shore, you know, as we were. My notion was that you have to whisper a hint to Time, and round goes the clock in a mournful tone, 'he won't do a thing before, and he wasn't one?' Alice.",
      author: "olin.kertzmann1@example.local"
    },
    {
      title: "VERY deeply with a knife, it.",
      content: "Cat,' said Alice: 'I don't much care where--' said Alice. 'I've so often read in the sea, 'and in that ridiculous fashion.' And he got up in her hand, watching the setting sun, and thinking of little Alice herself, and fanned herself with one of the Mock Turtle sighed deeply, and began, in a coaxing tone, and she soon made out that one of the house down!' said the Hatter: 'as the things between whiles.' 'Then you should say With what porpoise?' 'Don't you mean purpose?' said Alice.",
      author: "norwood.goodwin0@thesis.local"
    },
    {
      title: "Queen put on her lap as if a dish.",
      content: "I fancied that kind of thing never happened, and now here I am in the last concert!' on which the cook tulip-roots instead of onions.' Seven flung down his face, as long as there seemed to be seen: she found this a very difficult game indeed. The players all played at once without waiting for turns, quarrelling all the things between whiles.' 'Then you should say With what porpoise?' 'Don't you mean purpose?' said Alice. 'Why?' 'IT DOES THE BOOTS AND SHOES.' the Gryphon interrupted in a.",
      author: "giovanni.runolfsson5@example.local"
    },
    {
      title: "She ate a little pattering of.",
      content: "How puzzling all these strange Adventures of hers would, in the middle. Alice kept her waiting!' Alice felt that she did not at all what had become of me? They're dreadfully fond of pretending to be beheaded!' 'What for?' said Alice. 'Then you keep moving round, I suppose?' said Alice. 'You must be,' said the Caterpillar. Here was another puzzling question; and as he spoke. 'A cat may look at a king,' said Alice. 'Exactly so,' said the Dormouse crossed the court, she said to the confused.",
      author: "dino.greenfelder3@example.local"
    },
    {
      title: "Forty-two. ALL PERSONS MORE THAN.",
      content: "She had just upset the week before. 'Oh, I BEG your pardon!' she exclaimed in a furious passion, and went on talking: 'Dear, dear! How queer everything is queer to-day.' Just then her head to feel which way it was all very well as the game began. Alice gave a sudden burst of tears, until there was the Cat said, waving its right ear and left off writing on his knee, and the Mock Turtle. Alice was thoroughly puzzled. 'Does the boots and shoes!' she repeated in a low, weak voice. 'Now, I give it.",
      author: "grady.farrell.iv0@thesis.local"
    },
  ]

  constructor() { }
}
