#include <malloc.h>

void insertAbove(int value);
int showValueOfLabelAbove();
void dropAbove();

struct Label {
  int value;
  struct Label *following;
};

static struct Label *tail = NULL;

inline void insertAbove(int value) {
  struct Label *label = (struct Label *)malloc(sizeof(struct Label));
  label->value = value;
  label->following = tail;
  tail = label;
}

inline int showValueOfLabelAbove() {
  struct Label *label = tail;
  return label->value;
}

inline void dropAbove() {
  struct Label *taken = tail;
  tail = tail->following;
  free(taken);
}
