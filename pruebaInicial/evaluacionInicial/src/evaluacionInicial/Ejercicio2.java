package evaluacionInicial;

import java.util.Scanner;

public class Ejercicio2 {

	public static void main(String[] args) {
		Scanner sc=new Scanner (System.in);
		System.out.println("Introduzca un numero: ");
		int numero1=sc.nextInt();
		System.out.println("Introduzca otro numero: ");
		int numero2=sc.nextInt();
		for(int i=0;i<numero1+12;i++) {
			if(i>=numero1) {
				if(numero2*(i-numero1)>=numero1) {
					System.out.println(numero2*(i-numero1));
				}
				
				
			}
			
		}


	}

}
