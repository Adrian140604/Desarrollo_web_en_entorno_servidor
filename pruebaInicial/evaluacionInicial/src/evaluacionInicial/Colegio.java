package evaluacionInicial;

import java.util.ArrayList;
import java.util.List;

public class Colegio {
	
	private List nacionalidades=new ArrayList(); //Lo siento pero no me acuerdo como se creaba una lista :(
	
	public boolean addAlumno(String nacionalidad) {
		nacionalidades.add(nacionalidad);
		return true;
	}

	//Constructores
	public Colegio(List nacionalidades) {
		super();
		this.nacionalidades = nacionalidades;
	}
	//Getters and Setters

	public List getNacionalidades() {
		return nacionalidades;
	}

	public void setNacionalidades(List nacionalidades) {
		this.nacionalidades = nacionalidades;
	}
	
	
	
	
	
	
	

}
