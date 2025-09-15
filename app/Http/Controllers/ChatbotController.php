<?php

namespace App\Http\Controllers;

use App\Models\ClientesibstreamContacto;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;

class ChatbotController extends Controller
{
    public function handleBotRequest(BotMan $bot)
    {
        $bot->hears('hola', function (BotMan $bot) {
            $bot->reply("¡Hola! Soy AMPARO, tu Asesora Virtual. ¿Cómo puedo ayudarte hoy?");
            
            // Pide el nombre y apellido
            $bot->ask("Por favor, ¿cuál es tu nombre y apellido?", function ($answer, $bot) {
                $nombre = $answer->getText();
                $bot->userStorage()->save(['nombre' => $nombre]);
                
                // Luego, pide el teléfono
                $bot->ask("Gracias. Ahora, por favor, indícame tu número de teléfono (solo 9 dígitos):", function ($answer, $bot) {
                    $telefono = $answer->getText();
                    
                    if (preg_match('/^\d{9}$/', $telefono)) {
                        $bot->userStorage()->save(['telefono' => $telefono]);
                        $bot->reply("Gracias, tu información ha sido registrada correctamente.");

                        // Guardar en la base de datos
                        try {
                            ClientesibstreamContacto::create([
                                'nombre' => $nombre,
                                'telefono' => $telefono,
                            ]);
                            $bot->reply("Tu información se ha guardado correctamente.");
                        } catch (\Exception $e) {
                            $bot->reply("Hubo un error al guardar tus datos.");
                        }
                    } else {
                        $bot->reply("Por favor, ingresa un número de teléfono válido.");
                        $bot->ask("Por favor, indícame tu número de teléfono (solo 9 dígitos):", function ($answer, $bot) {
                            $telefono = $answer->getText();
                            $bot->userStorage()->save(['telefono' => $telefono]);
                        });
                    }
                });
            });
        });
    }

    // Método específico para la ruta /guardar-contacto
    public function guardarContacto(Request $request)
    {
        try {
            // Validar los datos recibidos
            $request->validate([
                'nombre' => 'required|string|max:255',
                'telefono' => 'required|string|regex:/^[0-9]{9}$/',
            ]);

            // Crear el registro en la base de datos
            $contacto = ClientesibstreamContacto::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contacto guardado correctamente',
                'data' => $contacto
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el contacto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para manejar los mensajes de datos (nombre y teléfono)
    public function handleMessage(Request $request)
    {
        // Lógica para manejar los datos enviados y guardarlos en la base de datos
        $data = $request->all();
        try {
            ClientesibstreamContacto::create([
                'nombre' => $data['nombre'],
                'telefono' => $data['telefono'],
            ]);
            return response()->json(['message' => 'Contacto guardado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar el contacto', 'error' => $e->getMessage()], 500);
        }
    }
}