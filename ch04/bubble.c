#include <stdio.h>
void bubble_sort(int [], int);
void bubble_sort(int list[], int n)
{
    int c, d, t, p;
    for (c = 0 ; c < n - 1; c++) {
        p = 0;
        for (d = 0 ; d < n - c - 1; d++) {
            if (list[d] > list[d+1]) {
                /* Swapping */
                t         = list[d];
                list[d]   = list[d+1];
                list[d+1] = t;
                p++;
            }
        }
        if (p == 0) break;
    }
}
