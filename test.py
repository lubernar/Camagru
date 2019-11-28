int u = 2;
int n = 1;
float e = 2.71828;
while (abs(u - e) >= 10**-2)
{
	u = (1 + (1/n))**n;
	n = n + 1;
}
print(n);
