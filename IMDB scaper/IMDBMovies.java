/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

Gathers data on movies from IMDB and saves them in a text file, formated for easy import though sql.
*/
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

public class IMDBMovies {
	public static void main(String[] args) {
		String[] targets = { "tt0848228", // avengers
				"tt2395427", // avenger-ultron
				"tt0458339", // capt amer
				"tt1843866", // capt amer-winter
				"tt0061578", // dirty dozen
				"tt0073195", // jaws
				"tt0120737", // lord of the rings
				"tt0903624", // hobbit
				"tt1298650", // Pirates (strange tides
				"tt0499549", // Avatar
				"tt0120338", // Titanic
				"tt0172495",// Gladiator
				"tt0133093", //Matrix
				"tt0109830", //Forrest Gump
				"tt1375666",//Inception
				"tt1853728",//Django
				"tt0361748",//Inglorious Basterds
				"tt0993846",//Wolf Of Wall Street
				"tt0816692",//Interstellar
				"tt2015381", //Guardians of the galaxy
				"tt0371746",//Iron man
				"tt0468569",//Dark night
				"tt1345836",//Dark night rises
				"tt1877832",//Xmen future past
				"tt0418279",//Transformers
				"tt0480249",//I am legend
				"tt0343818",//I robot
				"tt0119654",//Men in black
				"tt0120912",//Men in black 2
				"tt0116629", //Independance day
				"tt0319262",//Day after tomorrow
				"tt1190080",//2012
				"tt0407304",//War of the worlds
				"tt0120616",//The mummy
				"tt0167190",//Hellboy
				
		};
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("movies.txt"));
			String temp;
			for (int i = 0; i < targets.length; i++) {
				temp = "mov" + String.format("%03d", (i + 1));
				out.write(get(temp, targets[i]));
			}
			out.close();
		} catch (IOException e) {
		}
	}

	public static String get(String id, String code) {
		String whole = "";
		try {
			URL game = new URL("http://www.imdb.com/title/" + code + "/");
			URLConnection connection = game.openConnection();
			BufferedReader in = new BufferedReader(
					new InputStreamReader(connection.getInputStream()));
			String inputLine;
			while ((inputLine = in.readLine()) != null) {
				whole += inputLine;
			}
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		String desc = whole.substring(20 + whole.indexOf("rec-outline"));
		desc = desc.substring(0, desc.indexOf("</p>"));
		String title = whole.substring(25 + whole.indexOf("itemprop=\"name\""));
		title = title.substring(0, title.indexOf("<") - 6);
		String date = whole.substring(whole.indexOf("itemprop=\"datePublished\"") - 30,
				whole.indexOf("itemprop=\"datePublished\""));
		String country = date;
		date = date.substring(date.indexOf(">") + 1, date.indexOf("("));
		date = formatDate(date);
		country = country.substring(country.indexOf("(") + 1, country.indexOf(")"));
		// System.out.println(desc);
		// System.out.println(title);
		// System.out.println(date);
		// System.out.println(country);
		System.out.println(formatOutput(id, title, date, desc, country));
		return formatOutput(id, title, date, desc, country);
	}

	public static String formatDate(String input) {
		String temp[] = input.split(" ");
		if (temp[1].equals("January"))
			temp[1] = "1";
		else if (temp[1].equals("February"))
			temp[1] = "2";
		else if (temp[1].equals("March"))
			temp[1] = "3";
		else if (temp[1].equals("April"))
			temp[1] = "4";
		else if (temp[1].equals("May"))
			temp[1] = "5";
		else if (temp[1].equals("June"))
			temp[1] = "6";
		else if (temp[1].equals("July"))
			temp[1] = "7";
		else if (temp[1].equals("August"))
			temp[1] = "8";
		else if (temp[1].equals("September"))
			temp[1] = "9";
		else if (temp[1].equals("October"))
			temp[1] = "10";
		else if (temp[1].equals("November"))
			temp[1] = "11";
		else if (temp[1].equals("December"))
			temp[1] = "12";
		return (temp[2] + "-" + temp[1] + "-" + temp[0]);
	}

	public static String formatOutput(String id, String title, String date, String desc,
			String country) {
		return "\n('" + id + "',\n'" + title + "',\n'" + date + "',\n$$" + desc + "$$,\n'"
				+ country + "'),\n";

	}
}
