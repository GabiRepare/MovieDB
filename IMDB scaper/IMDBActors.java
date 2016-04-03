/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

Gathers data on actors from IMDB and saves them in a text file, formated for easy import though sql.
*/
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

public class IMDBActors {
	public static void main(String[] args) {
		String[] targets = { "nm0000375", // Downey
				"nm0262635", // Evans
				"nm0749263", // Ruffalo
				"nm1130627", // Smulders
				"nm0424060", // Johansson
				"nm1165110", // Hemsworth
				"nm0719637", // Renner
				"nm1089991", // Hiddleston
				"nm0163988",// Gregg

		};
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("actors.txt"));
			String temp;
			for (int i = 0; i < targets.length; i++) {
				temp = "act" + String.format("%04d", (i + 1));
				out.write(get(temp, targets[i]));
			}
			out.close();
		} catch (IOException e) {
		}
	}

	public static String get(String id, String code) {
		String whole = "";
		try {
			URL game = new URL("http://www.imdb.com/name/" + code + "/");
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
		String name = whole.substring(whole.indexOf("itemprop=\"name\">"));
		name = name.substring(16, name.indexOf("<"));
		String[] names = name.split(" ");
		String date = whole.substring(whole.indexOf("itemprop=\"birthDate\"") - 30,
				whole.indexOf("itemprop=\"birthDate\""));
		date = date.substring(date.indexOf("\"") + 1, date.length() - 2);

		String country = whole.substring(whole.indexOf("birth_place"));
		country = country.substring(0, country.indexOf("&ref_=nm_ov_bth"));
		country = country.substring(country.lastIndexOf("%20") + 3);
		String gender = "male";
		System.out.println(formatOutput(id, names[1], names[0], date, country, gender));
		return formatOutput(id, names[1], names[0], date, country, gender);
		// return " ";
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

	public static String formatOutput(String id, String lName, String fName, String date,
			String country, String gender) {
		return "\n('" + id + "',\n'" + lName + "',\n'" + fName + "',\n'" + date + "',\n'"
				+ country + "',\n'" + gender + "'),\n";

	}
}
