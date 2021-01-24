#include <stdio.h>
void shell_sort(int [], int);
int main()
{
  int arr[100], n, c;

  printf("Enter number of elements\n");
  scanf("%ld", &n);

  printf("Enter %ld integers\n", n);

  for (c = 0; c < n; c++)
    scanf("%ld", &arr[c]);

  shell_sort(arr, n);

  printf("Sorted list in ascending order:\n");

  for (c = 0; c < n; c++)
     printf("%ld\n", arr[c]);

  return 0;
}
