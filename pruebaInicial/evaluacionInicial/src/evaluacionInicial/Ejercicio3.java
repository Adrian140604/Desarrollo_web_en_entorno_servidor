package evaluacionInicial;

import java.util.Scanner;

public class Ejercicio3 {

	public static void main(String[] args) {
		Scanner sc=new Scanner (System.in);
		System.out.println("Introduzca un numero: ");
		int numero1=sc.nextInt();
		System.out.println("Introduzca otro numero: ");
		int numero2=sc.nextInt();
		int mayor=0;
		int menor=0;
		int contador=0;
		int resto=0;
		if(numero1>numero2) {
			mayor=numero1;
			menor=numero2;
		}
		else {
			mayor=numero2;
			menor=numero1;
		}
		for(int i=0;i<mayor;i++) {
			if (mayor!=0&&mayor-menor>=0) {
				mayor=mayor-menor;
				contador++;
				
			}
			if(mayor-menor<0) {
				resto=mayor;
			}
			
		}
		System.out.println("Cociente: "+contador);
		System.out.println("Resto: "+resto);
		
	}

}
