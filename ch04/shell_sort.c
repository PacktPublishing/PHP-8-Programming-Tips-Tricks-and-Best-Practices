#include<stdio.h>
/* Credit: the Crazy Programmer */
/* See: https://www.thecrazyprogrammer.com/2016/09/program-shell-sort-c.html */
void shell_sort(int a[],int n)
{
    int gap,i,j,temp;
    for(gap = n/2; gap > 0; gap /= 2)
    {
        for(i = gap; i < n; i+=1)
        {
            temp=a[i];
            for(j = i; j >= gap && a[j-gap] > temp; j -= gap)
                a[j] = a[j-gap];
            a[j] = temp;
        }
    }
}
