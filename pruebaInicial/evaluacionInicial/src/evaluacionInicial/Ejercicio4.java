package evaluacionInicial;

import java.util.Scanner;

public class Ejercicio4 {

	public static void main(String[] args) {
		Scanner sc=new Scanner (System.in);
		System.out.println("Introduzca un numero: ");
		int numero=sc.nextInt();
		
		while(numero!=1) {
			if(numero%2==0) {
				System.out.print(numero+"->");
				numero=numero/2;
				
			}
			else {
				System.out.print(numero+"->");
				numero=(numero*3)+1;
				
			}
		}
		System.out.println(numero);
		

		
	}

}
